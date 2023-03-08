messaggio = input("Inserisci il messaggio: ")

#richiedo la chiave finchè non è valida
key = input("Inserisci la chiave: ")
while (len(set(key)) != len(key) or len(key) == 0 or len(key) < len(messaggio)):
    key = input("Inserisci una chiave senza doppie e lunga almeno quanto il messaggio: ")


i = 0
for c in messaggio:
    c = ord(c) ^ ord(key[i])
    i += 1

print("Risultato: ", messaggio)